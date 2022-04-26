import * as React from "react"
import { Link } from "gatsby"

import ExternalLink from "./external-link"

import "../styles/app.scss"

const LayoutContainer = ({
  slug = 'page',
  title = null,
  subTitle = null,
  hero = null,
  children = null,
  nav = null
}) => {
  return (<>
    <header className="masthead">
      <h1>
        <Link to="/">Michael V. Colianna</Link>
      </h1>

      <p className="tagline">Author / Web Developer</p>

      <nav className="menu" aria-label="Site menu">
        <input id="menu-check" type="checkbox" hidden />

        <label
          id="menu-label"
          htmlFor="menu-check"
          className="unselectable"
          aria-controls="site-menu"
          hidden
        >
          <span className="icon close-icon">✕</span>
          <span className="icon open-icon">☰</span>
          <span className="text">Menu</span>
        </label>

        <ul id="site-menu">
          <li>
            <Link to="/">Home</Link>
          </li>

          <li>
            <Link to="/about">About</Link>
          </li>

          <li>
            <Link
              getProps={({ isPartiallyCurrent }) =>
                isPartiallyCurrent ? { 'aria-current': "page" } : null
              }
              to="/work"
            >
              Work
            </Link>
          </li>

          <li>
            <Link to="/stories">Stories</Link>
          </li>

          <li>
            <ExternalLink href="https://www.linkedin.com/in/michaelvcolianna/">
              LinkedIn
            </ExternalLink>
          </li>
        </ul>
      </nav>
    </header>

    <article className={`main ${slug}`}>
      {(title || subTitle || hero) && (
        <header className="title">
          {title && <h1>{title}</h1>}

          {subTitle && <h3>{subTitle}</h3>}

          {hero}

          <hr />
        </header>
      )}

      {children}

      <footer>
        {nav}

        <hr />

        <div className="copyright">
          © 2022 Michael V. Colianna
          |
          &nbsp;<ExternalLink href="https://github.com/michaelvcolianna/colianna.net">
            Source Code
          </ExternalLink>
        </div>
      </footer>
    </article>

    <div hidden>
      <span id="external-link-label">Opens an external site in a new window</span>
    </div>
  </>)
}

export default LayoutContainer
