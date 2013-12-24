VRBH Website Readme
========================

## Branch structure:
develop:    Development branch. All pull requests/commits should be made first to this branch. This branch can be
            unstable, however, this branch is merged into test when someone deploys, so you should not push really
            broken stuff.
test:       Once changes in develop pass tests, they can be merged into this branch for testing with live data onto the
            site. This site runs a database copy with live data, and a live android/ios app.
master:     The live vrbh site, any change pushed to this branch is automaticly deployed to the live site. Only test
            should be merged into develop.