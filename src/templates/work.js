import * as React from "react"
import { graphql, Link } from 'gatsby'

import LayoutContainer from "../components/layout"
import Seo from '../components/seo'
import RichText from '../components/rich-text'
import ImageWithCaption from "../components/image"

const WorkPage = ({
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
      title={title}
      subTitle={`Work / ${date}`}
      hero={
        <ImageWithCaption
          image={hero}
          alt={heroAlt}
          caption={heroCaption}
        />
      }
      nav={
        <nav className="post-nav">
          {previous && (
            <Link to={`../${previous.slug}`}>&#8592; {previous.title}</Link>
          )}

          {next && (
            <Link to={`../${next.slug}`}>{next.title} &#8594;</Link>
          )}
        </nav>
      }
    >
      <Seo
        customTitle={title}
        customDescription={description}
        customUrl={`work/${slug}`}
        customImage={hero}
      />

      <RichText richText={body} />
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
