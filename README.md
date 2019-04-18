# Codex Dev Project

Contains:

- Laravel project 
- Codex PHP packages
- Development files
- Intellij configuration


Branching:

- `codex/develop-ci` Tests
- `codex/develop-snapshot` Unit tests


CI/CD:

[CI/CD Server Dashboard](https://jenkins.radic.ninja/blue/pipelines)

| Job/Status     | Description    |
|------|-----|
| [![Build Status](https://jenkins.radic.ninja/buildStatus/icon?subject=codex%2Fdevelop%2Ftest&job=codex%2Fdevelop%2Ftest&style=flat-square)](https://jenkins.radic.ninja/blue/organizations/jenkins/codex%2Fdevelop%2Ftest) | Unit tests |
| [![Build Status](https://jenkins.radic.ninja/buildStatus/icon?subject=codex%2Fdevelop%2Fbuild-packages&job=codex%2Fdevelop%2Fbuild-packages&style=flat-square)](https://jenkins.radic.ninja/blue/organizations/jenkins/codex%2Fdevelop%2Fbuild-packages) | Merge theme assets to php packages |
| [![Build Status](https://jenkins.radic.ninja/buildStatus/icon?subject=codex%2Fdevelop%2Frelease&job=codex%2Fdevelop%2Frelease&style=flat-square)](https://jenkins.radic.ninja/blue/organizations/jenkins/codex%2Fdevelop%2Frelease) | ... |
| [![Build Status](https://jenkins.radic.ninja/buildStatus/icon?subject=codex%2Ftheme%2Fbuild&job=codex%2Ftheme%2Fbuild&style=flat-square)](https://jenkins.radic.ninja/blue/organizations/jenkins/codex%2Ftheme%2Fbuild) | Build theme |
| [![Build Status](https://jenkins.radic.ninja/buildStatus/icon?subject=codex.radic.ninja%2Fbuild&job=codex.radic.ninja%2Fbuild&style=flat-square)](https://jenkins.radic.ninja/blue/organizations/jenkins/codex.radic.ninjs%2Fbuild) | Build codex website |
| [![Build Status](https://jenkins.radic.ninja/buildStatus/icon?subject=codex.radic.ninja%2Fdeploy&job=codex.radic.ninja%2Fdeploy&style=flat-square)](https://jenkins.radic.ninja/blue/organizations/jenkins/codex.radic.ninjs%2Fdeploy) | Deploy codex website build |
| [![Build Status](https://jenkins.radic.ninja/buildStatus/icon?subject=packages.radic.ninja%2Fdeploy&job=packages.radic.ninja%2Fdeploy&style=flat-square)](https://jenkins.radic.ninja/blue/organizations/jenkins/packages.radic.ninjs%2Fdeploy) | Build and deploy satis |
