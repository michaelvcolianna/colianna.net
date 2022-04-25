import * as React from "react"
import { graphql } from 'gatsby'
import { GatsbyImage } from "gatsby-plugin-image"

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
        title: heroAlt,
        description: heroCaption,
        gatsbyImageData: hero
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
      customImage={hero}
    />

    <pre>{date}</pre>

    <div>
      <GatsbyImage
        image={hero}
        alt={heroAlt}
      />

      <p>{heroCaption}</p>
    </div>

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
        title
        description
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
          ... on ContentfulWork {
            contentful_id
            slug
            __typename
          }
        }
      }
    }
  }
`

export default WorkPage
