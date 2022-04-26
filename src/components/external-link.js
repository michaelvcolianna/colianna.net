import * as React from "react"

const ExternalLink = ({
  href,
  children
}) => {
  return (
    <a
      href={href}
      target="_blank"
      rel="noreferrer noopener"
      aria-describedby="external-link-label"
    >
      {children}
      <span className="ext-link">(new tab)</span>
    </a>
  )
}

export default ExternalLink
