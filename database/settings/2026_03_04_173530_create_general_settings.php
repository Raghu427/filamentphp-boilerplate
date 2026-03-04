<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Mi Sistema');
        $this->migrator->add('general.site_tagline', null);
        $this->migrator->add('general.site_description', null);

        $this->migrator->add('general.contact_email', null);
        $this->migrator->add('general.contact_phone', null);
        $this->migrator->add('general.address', null);

        $this->migrator->add('general.logo', null);
        $this->migrator->add('general.logo_dark', null);
        $this->migrator->add('general.favicon', null);
        $this->migrator->add('general.og_image', null);

        $this->migrator->add('general.meta_title', 'Mi Sistema');
        $this->migrator->add('general.meta_description', null);
        $this->migrator->add('general.meta_keywords', null);
        $this->migrator->add('general.meta_author', null);
        $this->migrator->add('general.meta_robots', null);
        $this->migrator->add('general.canonical_url', null);

        $this->migrator->add('general.og_title', 'Mi Sistema');
        $this->migrator->add('general.og_description', null);
        $this->migrator->add('general.og_type', 'website');

        $this->migrator->add('general.twitter_card', null);
        $this->migrator->add('general.twitter_site', null);

        $this->migrator->add('general.google_analytics_id', null);
        $this->migrator->add('general.google_tag_manager_id', null);
        $this->migrator->add('general.facebook_pixel_id', null);
    }
};
