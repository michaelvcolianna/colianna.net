import * as React from "react"
import { graphql } from 'gatsby'

const WorkPage = (data) => {
  return (
    <main>
      <h1>Work Page</h1>
      <pre>{JSON.stringify(data, null, 2)}</pre>
    </main>
  )
}

export const query = graphql`
  query($slug: String!) {
    work: contentfulWork(slug: {eq: $slug}) {
      title
      description {
        childMarkdownRemark {
          excerpt
        }
      }
      date
      hero {
        gatsbyImageData(placeholder: BLURRED)
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

export default WorkPage
