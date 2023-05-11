import React from 'react'
import { Link } from 'gatsby'

import Header from '@components/header'
import Footer from '@components/footer'
import Author from '@components/author'
import Intro from '@components/intro'
import PostNav from '@components/post-nav'
import RichText from '@components/rich-text'

import '../styles/main.scss'
import * as styles from './layout.module.scss'

const Layout = ({ page, previous = null, next = null, children }) => {
  return (
    <>
      <Link to="#content" className={styles.skipLink}>
        <span>Skip to the content</span>
      </Link>

      <Header />

      <main id="content">
        <Author />

        {!page.isHome && <Intro title={page.title}>{page.description.description}</Intro> }

        {children}

        {page.body && <RichText richText={page.body} />}

        {(previous || next) && <PostNav previous={previous} next={next} />}
      </main>

      <Footer />
    </>
  )
}

export default Layout
