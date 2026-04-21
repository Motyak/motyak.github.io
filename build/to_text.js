#!/usr/bin/env node

import { JSDOM } from "jsdom"
import fs from "fs"
import path from "path"
import { fileURLToPath } from "url"

let __dirname = path.dirname(fileURLToPath(import.meta.url))

let html = fs.readFileSync(0/*STDIN*/, "utf-8")

let dom = new JSDOM(html, {
    runScripts: "dangerously",
    resources: "usable", // required to run external script (jquery)
    url: `file://${__dirname}/` // otherwise relative paths don't work
})

dom.window.addEventListener("load", () => {
    let { window } = dom
    let scripts = window.document.querySelectorAll("script")
    scripts.forEach(script => script.remove())
    let styles = window.document.querySelectorAll("style")
    styles.forEach(style => style.remove())
    let text = window.document.body.textContent
            .replace(/\n{4,}/g, "\n\n\n")
            .replace(/^§(=== .+ ===\n)/gm, "$1\n")
            .split("\n").slice(1, -1).join("\n") // remove `Table of Contents`
    process.stdout.write(text)
    process.exit(0)
})
