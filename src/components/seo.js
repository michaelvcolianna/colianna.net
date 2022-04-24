import React from 'react'
import Helmet from 'react-helmet'
import { useStaticQuery, graphql } from 'gatsby'

const Seo = ({ customTitle, customDescription, customUrl, customImage }) => {
  const {
    site: {
      siteMetadata: { url, title, image, description },
    },
  } = useStaticQuery(graphql`
    {
      site {
        siteMetadata {
          url
          title
          image
          description
        }
      }
    }
  `)

  const seoTitle = customTitle
    ? `${customTitle} | ${title}`
    : title
  const seoDescription = customDescription || description
  const seoUrl = customUrl ? `${url}/${customUrl}` : url
  const seoImage = customImage
    ? `https://${customImage.images.fallback.src.replace(
      /\/\//g,
      ''
    )}`
  : `${url}/${image}`

  return (
    <Helmet>
      <html lang="en-US" />
      <title>{seoTitle}</title>
      <link rel="canonical" href={seoUrl} />
      <meta name="title" content={seoTitle} />
      <meta name="description" content={seoDescription} />
      <meta name="image" content={seoImage} />
      <meta property="og:type" content="website" />
      <meta property="og:url" content={seoUrl} />
      <meta property="og:title" content={seoTitle} />
      <meta property="og:description" content={seoDescription} />
      <meta property="og:image" content={seoImage} />
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:url" content={seoUrl} />
      <meta name="twitter:title" content={seoTitle} />
      <meta name="twitter:description" content={seoDescription} />
      <meta name="twitter:image" content={seoImage} />
      <link
        rel="icon"
        type="image/svg"
        sizes="16x16"
        href={`${url}/favicon.svg`}
        data-react-helmet="true"
      />
      <link
        rel="icon"
        type="image/svg"
        sizes="32x32"
        href={`${url}/favicon.svg`}
        data-react-helmet="true"
      />
    </Helmet>
  )
}

export default Seo
