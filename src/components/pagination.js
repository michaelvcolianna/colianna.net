import React from 'react'
import { Link } from 'gatsby'

import * as styles from './pagination.module.scss'

const Pagination = ({
  path = '/',
  info: {
    currentPage,
    hasNextPage,
    hasPreviousPage,
    pageCount
  }
}) => {
  // Build the appropriate next/previous urls
  const nextUrl = `${path}page/${currentPage + 1}`
  const previousUrl = currentPage === 2
    ? path
    : `${path}page/${currentPage - 1}`

  return (
    <>
      {(hasNextPage || hasPreviousPage) && (
        <nav aria-labelledby="label-pagination" className={styles.pagination}>
          <span id="label-pagination" className="sr">Pages of posts</span>

          {hasPreviousPage
            ? (
              <Link className={styles.link} to={previousUrl}>
                Newer
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" height="30" width="19" fill="currentColor"><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
              </Link>
            )
            : (
              <span className={styles.link} disabled>
                No newer posts
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" height="30" width="19" fill="currentColor"><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
              </span>
            )
          }

          <span className={styles.numbering}>
            Page {currentPage} of {pageCount}
          </span>

          {hasNextPage
            ? (
              <Link className={styles.link} to={nextUrl}>
                Older
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" height="30" width="19" fill="currentColor"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
              </Link>
            )
            : (
              <span className={styles.link} disabled>
                No older posts
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" height="30" width="19" fill="currentColor"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
              </span>
            )
          }
        </nav>
      )}
    </>
  )
}

export default Pagination
