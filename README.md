# Launch Layer Blog

An automated blog platform that generates SEO-optimized content using Claude AI, with Amazon affiliate book recommendations.

## Requirements

- XAMPP (or PHP 7.4+ with Apache)
- SQLite3 PHP extension enabled
- Claude API key from Anthropic

## Setup

1. **Enable SQLite3** in `php.ini`:
   ```
   extension=sqlite3
   ```
   Restart Apache after making this change.

2. **Configure API keys** in `config.php`:
   - `CLAUDE_API_KEY` - Your Anthropic API key
   - `AMAZON_AFFILIATE_TAG` - Your Amazon Associates tag

3. **Access the site** at `http://localhost/launch_layer_blog/`

## Generating Posts

Visit `http://localhost/launch_layer_blog/generate.php` to generate a new blog post.

The system will:
- Select the next unused topic from the predefined list
- Call Claude API to generate content
- Include 3 relevant book recommendations with affiliate links
- Save the post to the SQLite database

## Configuration Options

In `config.php`:
- `TESTING_MODE` - Set to `true` for 5-minute intervals, `false` for daily
- `POSTS_PER_PAGE` - Number of posts shown per page
- `BLOG_TITLE` / `BLOG_DESCRIPTION` - Site branding

## File Structure

- `index.php` - Homepage with post listings
- `post.php` - Individual post pages
- `generate.php` - Post generation endpoint
- `database.php` - Database functions
- `config.php` - Configuration settings
- `styles.css` - Site styling
- `blog.db` - SQLite database (created automatically)

## Topics

The blog includes 40 predefined topics covering:
- Management & Leadership
- Operations & Process
- Strategy & Planning
- Finance & Growth
- Customer & Marketing
- Team & Culture
- Productivity & Systems
- Problem Solving

## License

Copyright 2025 Launch Layer Labs. All rights reserved.
