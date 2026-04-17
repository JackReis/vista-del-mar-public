# VISTA DEL MAR PUBLIC REPO - COMPLETE FILE PACKAGE

This folder contains everything needed for your public GitHub repository.

## What's Included

### ✅ Safe for Public
- Bot HTML files (no API keys, no backend logic)
- John & Karen photo
- WordPress plugins (client-side only)
- GitHub Actions workflows (use secrets, not hardcoded values)
- Documentation

### ❌ NOT Included (Correctly)
- Kimi API key
- Cloudflare tokens (referenced via GitHub secrets)
- Private configuration
- AI Worker backend code

---

## FILE LIST

```
vista-del-mar-public/
├── README.md                          ← Start here
├── ask-the-owners/
│   └── index.html                     ← Public chatbot with photos
├── vistabot/
│   └── index.html                     ← Guest concierge
├── media/
│   └── john-karen.jpg                 ← Your parents' photo
├── wordpress-plugins/
│   ├── ask-the-owners.php             ← WordPress bot widget
│   ├── vista-concierge.php            ← Guest widget
│   └── vista-analytics.php            ← GA4 tracking
└── .github/workflows/
    ├── deploy-ask-owners.yml          ← Auto-deploy to Cloudflare
    └── deploy-vistabot.yml            ← Auto-deploy concierge
```

---

## SETUP INSTRUCTIONS

### Step 1: Create Repo (2 min)
https://github.com/new
- Name: `vista-del-mar-public`
- Visibility: **Public**
- Initialize: No (upload files instead)

### Step 2: Upload Files (5 min)
1. In your new repo, click "Add file" → "Upload files"
2. Drag the entire folder structure above
3. Commit to main branch

### Step 3: Add Secrets (2 min)
Go to: Settings → Secrets and variables → Actions

Add these from your private repo or 1Password:
- `CLOUDFLARE_API_TOKEN` = [your token]
- `CLOUDFLARE_ACCOUNT_ID` = [your account ID]

### Step 4: Deploy (2 min)
1. Go to Actions tab
2. Click "Deploy Ask the Owners"
3. Click "Run workflow"
4. Wait for green checkmark ✅

### Step 5: Test (1 min)
Visit: https://4b15c9f2.sea-ranch-public-bot.pages.dev

You should see John & Karen's photos (not emojis).

---

## AFTER PUBLIC REPO IS LIVE

Your WordPress site will automatically show the photos because:
- Bot URL stays: `https://4b15c9f2.sea-ranch-public-bot.pages.dev`
- Photo URL becomes: `https://raw.githubusercontent.com/JackReis/vista-del-mar-public/main/media/john-karen.jpg`

No changes needed on WordPress!

---

## UPDATED PRIVATE REPO

I've also updated your private repo (`sea-ranch-ai`) to point to the new public photo URL.

When you're ready, redeploy from private repo:
https://github.com/JackReis/sea-ranch-ai/actions/workflows/deploy-ask-owners.yml

Or just use the public repo exclusively for bot deployments.

---

## QUESTIONS?

**Why two repos?**
- Private: API keys, backend code, internal docs
- Public: Bots, photos, WordPress plugins (safe to share)

**Can I delete the private repo?**
No — keep it for the AI Worker backend and sensitive files.

**What if I update the bot?**
Update in BOTH repos, or pick one as your source of truth.

**Recommended:**
- Edit bots in **public repo** (easier to manage)
- Keep AI Worker in **private repo** (security)

---

Ready? Create the repo and upload these files. 🖤
