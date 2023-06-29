require('dotenv').config({
  path: `.env.${process.env.NODE_ENV}`
})

const appUrl = process.env.APP_URL || 'https://colianna.net'

const ctfSpaceId = process.env.CONTENTFUL_SPACE_ID
const ctfAccessToken = process.env.CONTENTFUL_ACCESS_TOKEN
const ctfHost = process.env.CONTENTFUL_HOST ?? 'cdn.contentful.com'

if(!ctfSpaceId || !ctfAccessToken) {
  throw new Error('Contentful spaceId and accessToken are missing')
}

/**
 * @type {import('gatsby').GatsbyConfig}
 */
module.exports = {
  siteMetadata: {
    perPage: 4,
    siteDescription: `Michael V. Colianna’s author and web developer site.`,
    siteImage: `${appUrl}/colianna-card.gif`,
    siteName: 'colianna.net',
    siteUrl: appUrl,
    title: 'colianna.net'
  },
  plugins: [
    'gatsby-plugin-image',
    'gatsby-transformer-sharp',
    'gatsby-plugin-sass',
    'gatsby-plugin-sitemap',
    {
      resolve: 'gatsby-source-contentful',
      options: {
        accessToken: ctfAccessToken,
        spaceId: ctfSpaceId,
        host: ctfHost
      }
    },
    {
      resolve: 'gatsby-transformer-remark',
      options: {
        plugins: [
          'gatsby-remark-copy-linked-files',
          'gatsby-remark-external-links',
          {
            resolve: 'gatsby-remark-images',
            options: {
              linkImagesToOriginal: false,
              maxWidth: 1200
            }
          }
        ]
      }
    },
    {
      resolve: 'gatsby-plugin-sharp',
      options: {
        defaults: {
          formats: ['auto', 'webp', 'avif']
        }
      }
    },
    {
      resolve: 'gatsby-plugin-manifest',
      options: {
        'icon': './src/images/favicon.svg'
      }
    },
    {
      resolve: 'gatsby-source-filesystem',
      options: {
        'name': 'images',
        'path': './src/images/'
      },
      __key: 'images'
    }
  ]
};