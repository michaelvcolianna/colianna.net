import React from 'react'

// Add the font preloads to the head
export const onRenderBody = ({ setHeadComponents }) => {
  setHeadComponents([
    <link
      rel="preload"
      href="/fonts/Poppins-Bold.woff2"
      as="font"
      type="font/woff2"
      crossOrigin="anonymous"
      key="poppinsBold"
    />,
    <link
      rel="preload"
      href="/fonts/Poppins-BoldItalic.woff2"
      as="font"
      type="font/woff2"
      crossOrigin="anonymous"
      key="poppinsBoldItalic"
    />,
    <link
      rel="preload"
      href="/fonts/Poppins-Regular.woff2"
      as="font"
      type="font/woff2"
      crossOrigin="anonymous"
      key="poppinsRegular"
    />,
    <link
      rel="preload"
      href="/fonts/Poppins-Italic.woff2"
      as="font"
      type="font/woff2"
      crossOrigin="anonymous"
      key="poppinsItalic"
    />,
  ])
}
