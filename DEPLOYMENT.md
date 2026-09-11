# Vercel Deployment

## Deploy from GitHub

1. Import `sheikhdipuraihan-sudo/AnimeWorld-India-Api-Streaming-api-for-hIndi-animes` into Vercel.
2. Use the repository root as the project root.
3. Leave the build command and output directory empty.
4. Deploy with the default Node.js project settings; PHP files are handled by `vercel-php`.

## Optional environment variables

Copy `.env.example` into the Vercel project variables when you want to restrict browser access:

- `ALLOWED_ORIGINS`: comma-separated allowed origins, or `*` for public access.
- `API_VERSION`: version reported by the health endpoint.

## Verification

After deployment, check:

```bash
curl https://YOUR_PROJECT.vercel.app/api/health
curl "https://YOUR_PROJECT.vercel.app/api/anime-world-india/v1/series.php?p=1"
```

The health response should contain `"status":"ok"`. API functions fetch source HTML at request time and do not require a database or persistent filesystem.

## Troubleshooting

- **404:** Confirm the Vercel project root is the repository root and the URL includes `.php` for API endpoints.
- **500:** Inspect Vercel Function logs; source-site availability or PHP extensions may be the cause.
- **CORS errors:** Set `ALLOWED_ORIGINS` to the exact frontend origin, including the scheme.
- **Slow responses:** The endpoints depend on an external source and proxy, so response time can vary.
