const path = require('path')

/**
 * Custom paginated page creation loop
 *
 * Running a loop like this inside the standard exports.createPages method will
 * mess up the Promise return, even if async. This custom function runs fine
 * inside the async method to create the paginated pages for any route.
 *
 * @param  object  createPage
 * @param  integer  count
 * @param  integer  limit
 * @param  string  template
 * @param  string  url
 * @param  string  slug
 * @return void
 */
const createPages = (
  createPage,
  count,
  limit,
  template,
  url,
  slug = null
) => {
  // Get total pages
  const pages = Math.ceil(count / limit)

  // Loop and create page numbers
  Array.from({ length: pages }).forEach((_, i) => {
    // Adjust current page from zero base
    const currentPage = i + 1

    createPage({
      path: i === 0 ? url : `${url}page/${currentPage}`,
      component: path.resolve(`./src/templates/${template}.js`),
      context: {
        limit: limit,
        skip: i * limit,
        pages,
        currentPage: currentPage,
        slug: slug
      }
    })
  })
}

// Add any import aliases
exports.onCreateWebpackConfig = ({ actions: { setWebpackConfig }}) => {
  setWebpackConfig({
    resolve: {
      alias: {
        '@components': path.resolve(__dirname, 'src/components')
      }
    }
  })
}

// Add pages
exports.createPages = async ({ graphql, reporter, actions: { createPage }}) => {
  // Get per page setting
  const settings = await graphql(`
    {
      site {
        siteMetadata {
          perPage
        }
      }
    }
  `)

  if(settings.error) {
    reporter.panicOnBuild(`Error in 'settings' query`)
  }

  const perPage = settings.data?.site?.siteMetadata?.perPage || 3

  // Get regular pages, work pages, and count for portfolio page(s)
  const allPages = await graphql(`
    {
      regular: allContentfulPage {
        pages: nodes {
          contentful_id
          slug
        }
      }
      work: allContentfulWork(sort: { date: DESC }) {
        count: totalCount
        edges {
          page: node {
            contentful_id
            slug
          }
          previous {
            contentful_id
            slug
          }
          next {
            contentful_id
            slug
          }
        }
      }
    }
  `)

  if(allPages.error) {
    reporter.panicOnBuild(`Error in 'allPages' query`)
    return
  }

  // Make the regular pages
  allPages.data?.regular?.pages?.forEach(page => {
    if(page.slug !== 'work') {
      createPage({
        path: page.slug === 'home' ? '/' : `/${page.slug}`,
        component: path.resolve('./src/templates/page.js'),
        context: {
          slug: page.slug
        }
      })
    }
  })

  // Paginate the portfolio pages
  createPages(
    createPage,
    allPages.data?.work?.count || 0,
    perPage,
    'portfolio',
    '/work/',
    'work'
  )

  // Make the work pages
  allPages.data?.work?.edges?.forEach(edge => {
    createPage({
      path: `/work/${edge.page.slug}`,
      component: path.resolve('./src/templates/work.js'),
      context: {
        slug: edge.page.slug,
        previous: edge.previous?.slug || null,
        next: edge.next?.slug || null
      }
    })
  })
}
