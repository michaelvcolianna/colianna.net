import * as React from "react"
import { graphql } from 'gatsby'

const RegularPage = (data) => {
  return (
    <main>
      <h1>Regular Page</h1>
      <pre>{JSON.stringify(data, null, 2)}</pre>
    </main>
  )
}

export const query = graphql`
  query($slug: String!) {
    contentfulPage(slug: {eq: $slug}) {
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
