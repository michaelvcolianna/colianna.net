import * as React from "react"
import { Link } from "gatsby"

const LayoutContainer = ({
  slug = null,
  title = null,
  children = null
}) => {
  return (<>
    <header>
      <div>
        <strong>colianna.net</strong>
      </div>

      <nav>
        <ul>
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
            <a
              href="https://www.linkedin.com/in/michaelvcolianna/"
              target="_blank"
              rel="noreferrer noopener"
              aria-describedby="external-link-label"
            >
              LinkedIn
            </a>
          </li>
        </ul>
      </nav>
    </header>

    <main rel={slug}>
      {title && <h1>{title}</h1>}

      {children || (
        <div>
          <em>No children specified</em>
        </div>
      )}
    </main>

    <footer>
      © 2022 Michael V. Colianna
    </footer>

    <div hidden>
      <span id="external-link-label">Opens an external site in a new window</span>
    </div>
  </>)
}

export default LayoutContainer
