---
title: Core Concepts
subtitle: Getting Started
---

# Core Concepts



<strong><c-c cyan>Codex</c-c> > <c-c deep-orange-9>Projects</c-c> > <c-c deep-orange-7>Project</c-c> > <c-c teal-9>Revisions</c-c> > <c-c teal-7>Revision</c-c> > <c-c pink-9>Documents</c-c> > <c-c pink-7>Document</c-c></strong>

- <c-c cyan>Codex</c-c> has one or more <c-c deep-orange-9>Projects</c-c>
- Each <c-c deep-orange-7>Project</c-c> has one or more <c-c teal-9>Revisions</c-c> <small>(branches/versions)</small>
- Each <c-c teal-7>Revision</c-c> contains <c-c pink-9>Documents</c-c>
- Each <c-c pink-7>Document</c-c> is passed trough several processors, modifying the output



```js
- docs
    - [project]
        - config.php
        - [revision]
            - revision.yml
            - [document]
            - [directory]
                - [document]

    - codex
        - config.php
        - master
            - revision.yml
            - index.md
            - getting-started
                - installation.md
                - configuration.md
        - 2.1.0
            - revision.yml
            - index.md
```


## Projects
Codex is structured 
