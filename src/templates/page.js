import React from 'react'
import { graphql } from 'gatsby'

import Layout from '@components/layout'
import Seo from '@components/seo'

const PageTemplate = ({ data: { page } }) => {
  return (
    <Layout page={page} />
  )
}

export default PageTemplate

export const query = graphql`
  query($slug: String!) {
    page: contentfulPage(slug: {eq: $slug}) {
      isHome
      slug
      title
      subTitle
      name
      description {
        description
      }
      body {
        raw
        references {
          ... on ContentfulAsset {
            __typename
            contentful_id
            title
            description
            gatsbyImageData(placeholder: BLURRED)
          }
          ... on ContentfulPage {
            __typename
            contentful_id
            slug
          }
        }
      }
    }
  }
`

export const Head = ({
  data: {
    page: {
      isHome,
      slug,
      title,
      name,
      description: {
        description
      }
    }
  }
}) => {
  return (
    <Seo
      title={title || name}
      description={description}
      url={isHome ? null : slug}
    />
  )
}
