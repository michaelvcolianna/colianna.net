import React from 'react'
import { StaticImage } from 'gatsby-plugin-image'

import * as styles from './author.module.scss'

const Author = () => {
  return (
    <div className={styles.author}>
      <StaticImage alt="" src="../images/mvc-lavender.jpg" />

      <strong>
        Michael V. Colianna
        <span>Author / Web Developer</span>
      </strong>
    </div>
  )
}

export default Author
