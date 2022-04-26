import * as React from "react"
import { GatsbyImage } from "gatsby-plugin-image"

const ImageWithCaption = ({
  image,
  alt,
  caption
}) => {
  return (
    <div className="figure">
      <GatsbyImage
        image={image}
        alt={alt}
      />

      <p className="figcaption">{caption}</p>
    </div>
  )
}

export default ImageWithCaption
