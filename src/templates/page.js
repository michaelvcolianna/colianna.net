import * as React from "react"
import { graphql } from 'gatsby'

import Seo from '../components/seo'
import RichText from '../components/rich-text'

const RegularPage = ({
  data,
  data: {
    page: {
      isHome,
      slug,
      title,
      name,
      description: {
        childMarkdownRemark: {
          excerpt: description
        }
      },
      body
    }
  }
}) => {
  return (<>
    <Seo
      customTitle={title || name}
      customDescription={description || null}
      customUrl={isHome ? null : slug}
    />

    <RichText richText={body} />
  </>)
}

export const query = graphql`
  query($slug: String!) {
    page: contentfulPage(slug: {eq: $slug}) {
      isHome
      slug
      title
      name
      description {
        childMarkdownRemark {
          excerpt
        }
      }
      body {
        raw
        references {
          ... on ContentfulAsset {
            contentful_id
            title
            description
            gatsbyImageData(placeholder: BLURRED)
            __typename
          }
        }
      }
    }
  }
`

export default RegularPage
