import React from 'react'
import { graphql } from 'gatsby'

import Layout from '@components/layout'
import Seo from '@components/seo'
import BackToWork from '@components/back-to-work'

const WorkTemplate = ({
  data: {
    work,
    previous,
    next
  }
}) => {
  return (
    <Layout page={work} previous={previous} next={next}>
      <BackToWork />
    </Layout>
  )
}

export default WorkTemplate

export const query = graphql`
  query($slug: String!, $previous: String, $next: String) {
    work: contentfulWork(slug: { eq: $slug }) {
      slug
      title
      description {
        description
      }
      date(formatString: "YYYY-MM-DD")
      hero {
        title
        description
        gatsbyImageData(placeholder: BLURRED)
        src: url
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
          ... on ContentfulWork {
            __typename
            contentful_id
            slug
          }
        }
      }
    }
    previous: contentfulWork(slug: { eq: $next }) {
      slug
      title
    }
    next: contentfulWork(slug: { eq: $previous }) {
      slug
      title
    }
  }
`

export const Head = ({
  data: {
    work: {
      slug,
      title,
      name,
      description: {
        description
      },
      hero: {
        src
      }
    }
  }
}) => {
  return (
    <Seo
      title={title || name}
      description={description}
      url={`work/${slug}`}
      image={src}
    />
  )
}
