---
title: Core Concepts
subtitle: Getting Started
---

# Core Concepts


### Application flow

<pre><strong><c-c cyan>Codex</c-c> > <c-c deep-orange-7>Projects</c-c> > <c-c teal-7>Revisions</c-c> > <c-c pink-7>Documents</c-c></strong></pre> 

- <c-c cyan>Codex</c-c> has one or more <c-c deep-orange-7>Projects</c-c>
- Each <c-c deep-orange-7>Project</c-c> has one or more <c-c teal-7>Revisions</c-c> <small>(branches/versions)</small>
- Each <c-c teal-7>Revision</c-c> contains <c-c pink-7>Documents</c-c>
- Each <c-c pink-7>Document</c-c> is passed trough several processors, modifying the output

### Directory Structure
<!--*codex:col(
<pre>- <c-c cyan>docs</c-c>
  - [<c-c deep-orange-7>project</c-c>]
    - <c-c >config.php</c-c>
    - [<c-c teal-7>revision</c-c>]
      - <c-c >revision.yml</c-c>
      - [<c-c pink-7>document</c-c>]
      - [<c-c>directory</c-c>]
        - [<c-c pink-7>document</c-c>]
</pre>
<pre>- <c-c deep-orange-7>codex</c-c>
    - <c-c >config.php</c-c>
    - <c-c teal-7>master</c-c>
      - <c-c >revision.yml</c-c>
      - <c-c pink-7>index.md</c-c>
      - <c-c>getting-started</c-c>
        - <c-c pink-7>installation.md</c-c>
        - <c-c pink-7>configuration.md</c-c>
    - <c-c teal-7>2.1.0</c-c>
      - <c-c >revision.yml</c-c>
      - <c-c pink-7>index.md</c-c>
</pre>

## Projects

> A nice blockquote
{: title="Blockquote title"}

{#id .class}
## Header


Codex is structured 
