import React from 'react'
import { useStaticQuery, graphql } from 'gatsby'

const Seo = ({
  title = null,
  description = null,
  url = null,
  image = null,
  bodyClass = null
}) => {
  const {
    site: {
      siteMetadata: {
        siteDescription,
        siteImage,
        siteName,
        siteUrl
      }
    }
  } = useStaticQuery(graphql`
    {
      site {
        siteMetadata {
          siteDescription
          siteImage
          siteName
          siteUrl
        }
      }
    }
  `)

  // Determine/set the values that can vary
  const seoDescription = description ?? siteDescription
  const seoImage = image
    ? `${siteUrl}${image}`
    : siteImage
  const seoTitle = title
    ? `${title} - ${siteName}`
    : siteName
  const seoUrl = url
    ? `${siteUrl}/${url}/`
    : siteUrl

  return (
    <>
      <html lang="en" />
      <title>{seoTitle}</title>
      <meta name="title" content={seoTitle} />
      <meta property="og:title" content={seoTitle} />
      <meta name="twitter:title" content={seoTitle} />
      <link rel="canonical" href={seoUrl} />
      <meta property="og:url" content={seoUrl} />
      <meta name="twitter:url" content={seoUrl} />
      <meta name="description" content={seoDescription} />
      <meta property="og:description" content={seoDescription} />
      <meta name="twitter:description" content={seoDescription} />
      <meta name="image" content={seoImage} />
      <meta property="og:image" content={seoImage} />
      <meta name="twitter:image" content={seoImage} />
      <meta property="og:type" content="website" />
      <meta name="twitter:card" content="summary_large_image" />
      <body className={bodyClass} />
    </>
  )
}

export default Seo
