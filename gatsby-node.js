const path = require('path')

exports.createPages = async({ graphql, actions }) => {
  const { createPage } = actions

  const regularPageTemplate = path.resolve(`src/templates/page.js`)

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
    }
  `)

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
}
