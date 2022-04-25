import * as React from "react"
import { INLINES, BLOCKS, MARKS } from '@contentful/rich-text-types'
import { renderRichText } from 'gatsby-source-contentful/rich-text'
import { GatsbyImage } from "gatsby-plugin-image"

const options = {
  renderMark: {
    [MARKS.BOLD]: (text) => <strong>{text}</strong>,
    [MARKS.ITALIC]: (text) => <em>{text}</em>,
    [MARKS.UNDERLINE]: (text) => <u>{text}</u>,
    [MARKS.CODE]: (text) => <code>{text}</code>
  },
  renderNode: {
    [INLINES.HYPERLINK]: (node, children) => (
      <a
        href={node.data.uri}
        target="_blank"
        rel="noreferrer noopener"
      >
        {children}
      </a>
    ),
    [BLOCKS.HEADING_1]: (node, children) => <h2 data-heading="h1">{children}</h2>,
    [BLOCKS.PARAGRAPH]: (node, children) => {
      return node.content[0].value === ''
        ? <br />
        : <p>{children}</p>
    },
    [BLOCKS.EMBEDDED_ASSET]: (node) => {
      const { gatsbyImageData, title, description } = node.data.target

      return (
        <div>
          <GatsbyImage
            image={gatsbyImageData}
            alt={title}
          />

          <p>{description}</p>
        </div>
      )
    }
  }
}

const RichText = ({ richText }) => {
  return <div>{renderRichText(richText, options)}</div>
}

export default RichText
