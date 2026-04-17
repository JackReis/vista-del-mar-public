# Vista Del Mar Public Assets
**Public repository for Sea Ranch vacation rental bots and assets**

## What's In This Repo (Safe for Public)

### Bots
- `ask-the-owners/` — Public guest chatbot
- `vistabot/` — Guest concierge bot (keep disabled on public pages)

### Photos
- `media/john-karen.jpg` — John & Karen avatar photo

### WordPress Plugins
- `wordpress-plugins/ask-the-owners.php` — Embeddable bot widget
- `wordpress-plugins/vista-concierge.php` — Guest concierge widget
- `wordpress-plugins/vista-analytics.php` — GA4 tracking plugin

### Documentation
- `README.md` — Overview
- `DEPLOYMENT.md` — How to deploy bots
- `CHANGELOG.md` — Version history

### GitHub Actions
- `.github/workflows/deploy-ask-owners.yml`
- `.github/workflows/deploy-vistabot.yml`

## What's NOT In This Repo (Private)

- API keys (Kimi, Cloudflare)
- Private configuration
- Internal documents
- AI Worker backend code (separate private repo)

## Live URLs

| Asset | URL |
|-------|-----|
| Ask the Owners Bot | https://4b15c9f2.sea-ranch-public-bot.pages.dev |
| Vista Concierge Bot | https://1d073f18.vista-guest-bot.pages.dev |
| John & Karen Photo | https://raw.githubusercontent.com/JackReis/vista-del-mar-public/main/media/john-karen.jpg |

## Setup

### Deploy Bots
1. Push to this repo
2. GitHub Actions auto-deploys to Cloudflare Pages
3. Requires: `CLOUDFLARE_API_TOKEN` and `CLOUDFLARE_ACCOUNT_ID` secrets

### Install WordPress Plugin
1. Download `wordpress-plugins/vista-analytics.php`
2. WordPress Admin → Plugins → Add New → Upload
3. Activate

## License

Private — for Vista Del Mar use only.
