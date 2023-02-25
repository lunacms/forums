<?php 

namespace Lunacms\Forums\Models\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Lunacms\Forums\Tags\Models\Tag;

/**
 * Entity can create and be associated with tags.
 */
trait HasTagsTrait
{
    /**
     * Boot trait.
     */
    public static function bootHasTagsTrait()
    {
        //
    }

    /**
     * Handles adding and deleting of entity tags.
     *
     * @param array|int|mixed $tags
     */
    public function syncTags($tags)
    {
        $this->removeNonExistingTags($tags);

        $this->addTags($tags);
    }

    /**
     * Add tags to entity.
     *
     * @param $tags
     */
    public function addTags($tags)
    {
        $this->tags()->syncWithoutDetaching($this->getWorkableTags(Arr::wrap($tags)));
    }

    /**
     * Removes given tags from entity.
     *
     * @param array|int|mixed $tags
     */
    public function detachTags($tags)
    {
        $this->tags()->detach($this->getWorkableTags($tags));
    }

    /**
     * Delete tags from entity which are no longer required or available.
     *
     * @param $tags
     */
    public function removeNonExistingTags($tags)
    {
        if (!$tags) {
            return;
        }

        if (!$this->tags->count()) {
            return;
        }

        $oldTags = $this->tags()
            ->whereNotIn('id', $this->getWorkableTags($tags))
            ->pluck('id')
            ->toArray();

        $this->tags()->detach($oldTags);
    }

    /**
     * Get the permission ID from the mixed value.
     *
     * @param $value
     * @return mixed
     */
    public function parseTagId($value)
    {
        return $value instanceof Tag ? $value->id : $value;
    }

    /**
     * Get a collection of valid tags from ids.
     *
     * @param  array $tags
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getTagsCollectionFromIds(array $tags)
    {
        return Tag::query()->whereIn('id', $tags)->get();
    }

    /**
     * Get an array of valid tags ids.
     *
     * @param array $tags
     * @return array
     */
    protected function getTagsIds(array $tags)
    {
        return Tag::query()
            ->whereIn('id', $tags)
            ->get()
            ->pluck('id')
            ->all();
    }

    /**
     * Filter out collection of tags which are not instance of `Tag` model.
     *
     * @param  \Illuminate\Support\Collection $tags
     * @return Collection
     */
    protected function filterTagsCollection(Collection $tags)
    {
        return $tags->filter(function ($permission) {
            return $permission instanceof Tag;
        });
    }

    /**
     * Check and return an array of permission ids.
     *
     * @param  int|array|\Lunacms\Forums\Tags\Models\Tag|\Illuminate\Support\Collection $tags
     * @return array
     */
    protected function getWorkableTags($tags)
    {
        if (is_int($tags)) {
            return array($tags);
        }

        if (is_array($tags)) {
            return Arr::wrap($this->getTagsIds($tags));
        }

        if ($tags instanceof Tag) {
            return array($tags->id);
        }

        if ($tags instanceof Collection) {
            return Arr::wrap($this->filterTagsCollection($tags)->pluck('id')->all());
        }
    }

    /**
     * Get all of the tags for the given model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
