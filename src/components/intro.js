import React from 'react'

import * as styles from './intro.module.scss'

const Intro = ({ title, children, dot = true }) => {
  return (
    <section className={styles.intro}>
      <h1 className={dot ? 'dot' : ''}>{title}</h1>

      {children}
    </section>
  )
}

export default Intro
