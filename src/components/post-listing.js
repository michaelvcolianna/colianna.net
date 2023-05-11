import React from 'react'
import { Link } from 'gatsby'

import * as styles from './post-listing.module.scss'

const PostListing = ({ items }) => {
  return (
    <section>
      {items.map(item => (
        <div key={item.contentful_id} className={styles.summary}>
          <time dateTime={item.dateTime}>{item.date}</time>

          <h2>
            <Link to={`/work/${item.slug}`}>{item.title}</Link>
          </h2>

          <p>{item.description.description}</p>
        </div>
      ))}
    </section>
  )
}

export default PostListing
