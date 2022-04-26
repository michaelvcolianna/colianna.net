import * as React from "react"
import { GatsbyImage } from "gatsby-plugin-image"

const ImageWithCaption = ({
  image,
  alt,
  caption
}) => {
  return (
    <div>
      <GatsbyImage
        image={image}
        alt={alt}
      />

      <p>{caption}</p>
    </div>
  )
}

export default ImageWithCaption
