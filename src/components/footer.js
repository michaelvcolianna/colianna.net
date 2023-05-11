import React from 'react'

import ExternalLink from '@components/external-link'

import * as styles from './footer.module.scss'

const Footer = () => {
  return (
    <footer className={styles.siteFooter}>
      <p>
        <span>&copy; 1997–{new Date().getFullYear()} Michael V. Colianna.</span>
        <span>|</span>
        <ExternalLink href="https://www.linkedin.com/in/michaelvcolianna/">LinkedIn</ExternalLink>
        <span>|</span>
        <ExternalLink href="https://github.com/michaelvcolianna/colianna.net">Source Code</ExternalLink>
      </p>
    </footer>
  )
}

export default Footer
