import * as React from "react"

const RegularPage = (data) => {
  return (
    <main>
      <h1>Regular Page</h1>
      <pre>{JSON.stringify(data, null, 2)}</pre>
    </main>
  )
}

export default RegularPage
