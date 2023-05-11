import React from 'react'
import { Link } from 'gatsby'

import * as styles from './post-nav.module.scss'

const PostNav = ({ previous = null, next = null }) => {
  return (
    <nav aria-labelledby="label-postnav">
      <span id="label-postnav" className="sr">Previous/next posts</span>

      <ul className={styles.postNav}>
        {previous && (
          <li className={styles.previousPost}>
            <span>Previous</span>

            <Link to={`/work/${previous.slug}`}>
              {previous.title}
            </Link>
          </li>
        )}

        {next && (
          <li className={styles.nextPost}>
            <span>Next</span>

            <Link to={`/work/${next.slug}`}>
              {next.title}
            </Link>
          </li>
        )}
      </ul>
    </nav>
  )
}

export default PostNav
