import * as React from "react"
import { graphql } from 'gatsby'

import Seo from '../components/seo'
import RichText from '../components/rich-text'

const WorkPage = ({
  data,
  data: {
    work: {
      slug,
      title,
      description: {
        childMarkdownRemark: {
          excerpt: description
        }
      },
      date,
      hero: {
        gatsbyImageData: image
      },
      body
    }
  }
}) => {
  return (<>
    <Seo
      customTitle={title}
      customDescription={description}
      customUrl={`work/${slug}`}
      customImage={image}
    />

    <pre>{date}</pre>

    <RichText richText={body} />
  </>)
}

export const query = graphql`
  query($slug: String!) {
    work: contentfulWork(slug: {eq: $slug}) {
      slug
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

export default WorkPage
