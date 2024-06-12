# Songbook
A very simple app to share the texts of a list of songs.

## Installation and usage
1. clone the repo
2. `cd` into the `app` folder
3. run `composer install`
4. run `ddev start` to bring up the local server – the app can be reached 
   with http://songbook.ddev.site
5. run `ddev composer install`
6. Add your songs to `/app/content/songs` as markdown files with front matter. 
   The front matter can contain the following fields:
   * title (required)
   * artist
   * ccli-number
   * copyright
   * copyright-text
   * ccli-license 

The web root is at `/app/public`.
