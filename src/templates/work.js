import * as React from "react"
import { graphql, Link } from 'gatsby'
import { GatsbyImage } from "gatsby-plugin-image"

import LayoutContainer from "../components/layout"
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
    },
    previous,
    next
  }
}) => {
  return (
    <LayoutContainer
      slug={`work.${slug}`}
      title={title}
    >
      <Seo
        customTitle={title}
        customDescription={description}
        customUrl={`work/${slug}`}
        customImage={hero}
      />

      <Link to="/work">&lsaquo; Back to Work</Link>

      <p>{date}</p>

      <div>
        <GatsbyImage
          image={hero}
          alt={heroAlt}
        />

        <p>{heroCaption}</p>
      </div>

      <RichText richText={body} />

      {previous && (
        <Link to={`../${previous.slug}`}>&laquo; {previous.title}</Link>
      )}

      {next && (
        <Link to={`../${next.slug}`}>{next.title} &raquo;</Link>
      )}
    </LayoutContainer>
  )
}

export const query = graphql`
  query($slug: String!, $previous: String, $next: String) {
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
    previous: contentfulWork(slug: {eq: $previous}) {
      slug
      title
    }
    next: contentfulWork(slug: {eq: $next}) {
      slug
      title
    }
  }
`

export default WorkPage
