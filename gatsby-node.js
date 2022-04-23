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
      allContentfulWork {
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
  result.data.allContentfulWork.edges.forEach(edge => {
    createPage({
      path: `work/${edge.node.slug}`,
      component: workPageTemplate,
      context: {
        slug: edge.node.slug
      }
    })
  })
}
