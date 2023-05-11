import React from 'react'
import { GatsbyImage } from 'gatsby-plugin-image'

const ImageWithCaption = ({ image, alt, caption }) => {
  return (
    <figure>
      <GatsbyImage
        image={image}
        alt={alt}
      />

      <figcaption>{caption}</figcaption>
    </figure>
  )
}

export default ImageWithCaption
