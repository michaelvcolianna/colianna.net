import * as React from "react"

const WorkPage = (data) => {
  return (
    <main>
      <h1>Work Page</h1>
      <pre>{JSON.stringify(data, null, 2)}</pre>
    </main>
  )
}

export default WorkPage
