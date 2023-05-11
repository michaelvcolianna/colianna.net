import React, { useState, useEffect, useCallback } from 'react'
import { Link } from 'gatsby'

import * as styles from './header.module.scss'

const Header = () => {
  // Set up the state for the navigation menu
  const [menuOpen, setMenuOpen] = useState(false)

  // Handler for opening/closing the menu
  const toggleMenu = () => {
    if(menuOpen) {
      setMenuOpen(false)
      document.body.dataset.menuOpen = false
    }
    else {
      setMenuOpen(true)
      document.body.dataset.menuOpen = true
    }
  }

  // Callback to correct the menu on resize beyond breakpoints
  const windowResizeHandler = useCallback(() => {
    if(window.innerWidth > 768) {
      setMenuOpen(true)
      document.body.dataset.menuOpen = true
    }
    else {
      setMenuOpen(false)
      document.body.dataset.menuOpen = false
    }
  }, [])

  // Run the resize handler on load
  useEffect(() => {
    windowResizeHandler()
  }, [windowResizeHandler])

  // Effect to handle closing the menu via escape key
  useEffect(() => {
    const keyDownHandler = event => {
      if(event.key === 'Escape' && menuOpen) {
        setMenuOpen(false)
      }
    }

    document.addEventListener('keydown', keyDownHandler)

    return() => {
      document.removeEventListener('keydown', keyDownHandler)
    }
  }, [menuOpen])

  // Run the resize handler on resize
  useEffect(() => {
    window.addEventListener('resize', windowResizeHandler)

    return() => {
      document.removeEventListener('resize', windowResizeHandler)
    }
  }, [windowResizeHandler])

  return (
    <header className={styles.siteHeader}>
      <Link to="/" className={styles.branding}>colianna.net</Link>

      <button
        className={styles.menuButton}
        id="site-menu-button"
        onClick={toggleMenu}
        aria-controls="site-menu"
        aria-expanded={menuOpen}
      >
        <span>Pages</span>
      </button>

      <nav
        className={styles.menu}
        id="site-menu"
        aria-labelledby="site-menu-button"
        aria-hidden={!menuOpen}
      >
        <ul>
          <li>
            <Link to="/">Home</Link>
          </li>

          <li>
            <Link to="/about">About</Link>
          </li>

          <li>
            <Link
              to="/work"
              activeClassName="partial"
              partiallyActive={true}
            >
              Work
            </Link>
          </li>

          <li>
            <Link to="/stories">Stories</Link>
          </li>
        </ul>
      </nav>
    </header>
  )
}

export default Header
