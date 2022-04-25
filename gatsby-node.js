const path = require('path')

exports.createPages = async({ graphql, actions }) => {
  const { createPage } = actions

  const regularPageTemplate = path.resolve(`src/templates/page.js`)
  const workPageTemplate = path.resolve(`src/templates/work.js`)

  const result = await graphql(`
    query {
      allContentfulPage {
        edges {
          node {
            slug
            isHome
          }
        }
      }
      allContentfulWork(sort: { fields: date, order: DESC }) {
        edges {
          node {
            slug
          }
        }
      }
    }
  `)

  // Add top-level pages
  result.data.allContentfulPage.edges.forEach(edge => {
    let pagePath = edge.node.isHome
      ? `/`
      : `${edge.node.slug}`

    createPage({
      path: pagePath,
      component: regularPageTemplate,
      context: {
        slug: edge.node.slug
      }
    })
  })

  // Add work pages
  const workPages = result.data.allContentfulWork.edges
  workPages.forEach((edge, index) => {
    const previousWork = index === workPages.length - 1
      ? null
      : workPages[index + 1]?.node.slug
    const nextWork = index === 0
      ? null
      : workPages[index - 1]?.node.slug

    createPage({
      path: `work/${edge.node.slug}`,
      component: workPageTemplate,
      context: {
        slug: edge.node.slug,
        previous: previousWork,
        next: nextWork
      }
    })
  })
}
