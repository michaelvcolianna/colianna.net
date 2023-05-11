import React from 'react'
import { Link } from 'gatsby'
import { INLINES, BLOCKS, MARKS } from '@contentful/rich-text-types'
import { renderRichText } from 'gatsby-source-contentful/rich-text'

import ExternalLink from '@components/external-link'
import ImageWithCaption from '@components/image-with-caption'

import * as styles from './rich-text.module.scss'

/**
 * Options for rendering the AST returned by Contentful's rich text fields.
 *
 * @var object
 */
const options = {
  renderMark: {
    [MARKS.BOLD]: (text) => <strong>{text}</strong>,
    [MARKS.ITALIC]: (text) => <em>{text}</em>,
    [MARKS.UNDERLINE]: (text) => <u>{text}</u>,
    [MARKS.CODE]: (text) => <code>{text}</code>
  },
  renderNode: {
    [INLINES.HYPERLINK]: (node, children) => (
      <ExternalLink href={node.data.uri}>{children}</ExternalLink>
    ),
    [INLINES.ENTRY_HYPERLINK]: (node, children) => {
      // Determine whether this URL is for a regular or work page
      const pageType = node.data.target.__typename.replace('Contentful', '/').toLowerCase()
      const pathPrefix = pageType === '/work'
        ? pageType
        : ''

      return <Link to={`${pathPrefix}/${node.data.target.slug}`}>{children}</Link>
    },
    [BLOCKS.HEADING_1]: (node, children) => <h2 data-heading="h1">{children}</h2>,
    [BLOCKS.PARAGRAPH]: (node, children) => {
      // Account for shift+return breaks
      return node.content[0].value === ''
        ? <br />
        : <p>{children}</p>
    },
    [BLOCKS.EMBEDDED_ASSET]: (node) => {
      // Utilize the custom component for inline images
      const { gatsbyImageData, title, description } = node.data.target

      return (
        <ImageWithCaption
          image={gatsbyImageData}
          alt={title}
          caption={description}
        />
      )
    }
  }
}

const RichText = ({ richText }) => {
  return <div className={styles.content}>{renderRichText(richText, options)}</div>
}

export default RichText
