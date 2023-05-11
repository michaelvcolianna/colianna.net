import React from 'react'
import { graphql } from 'gatsby'

import Layout from '@components/layout'
import Seo from '@components/seo'
import PostListing from '@components/post-listing'
import Pagination from '@components/pagination'

const PortfolioTemplate = ({
  data: {
    page,
    work: {
      items,
      pagination
    }
  }
}) => {
  return (
    <Layout page={page}>
      <PostListing items={items} />

      <Pagination info={pagination} path="/work/" />
    </Layout>
  )
}

export default PortfolioTemplate

export const query = graphql`
  query($slug: String!, $limit: Int!, $skip: Int!) {
    page: contentfulPage(slug: { eq: $slug }) {
      isHome
      slug
      title
      subTitle
      name
      description {
        description
      }
    }
    work: allContentfulWork(
      sort: { date: DESC },
      limit: $limit,
      skip: $skip
    ) {
      pagination: pageInfo {
        currentPage
        hasNextPage
        hasPreviousPage
        itemCount
        pageCount
        perPage
        totalCount
      }
      items: nodes {
        contentful_id
        title
        slug
        dateTime: date
        date(fromNow: true)
        description {
          description
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
