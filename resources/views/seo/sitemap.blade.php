<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <!-- Songs Directory -->
    <url>
        <loc>{{ route('songs.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <!-- Artists Directory -->
    <url>
        <loc>{{ route('artists.index') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <!-- Song Detail Pages -->
    @foreach($songs as $song)
        <url>
            <loc>{{ route('songs.show', $song->slug) }}</loc>
            <lastmod>{{ $song->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    <!-- Artist Profile Pages -->
    @foreach($artists as $artist)
        <url>
            <loc>{{ route('artists.show', $artist->slug) }}</loc>
            <lastmod>{{ $artist->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
