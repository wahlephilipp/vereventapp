<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model {
	use SoftDeletes;

	protected $fillable = [
		'title',
		'description_short',
		'description',
		'price',
		'finished',
		'live',
		'private',
	];

	/**
	 * Belong to User
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( User::class );
	}

	/**
	 * Determinate if the event is free
	 *
	 * @return bool
	 */
	public function isFree() {
		return $this->price == 0;
	}

	/**
	 * Get all finished Events
	 *
	 * @param Builder $builder
	 *
	 * @return Builder $builder
	 */
	public function scopeIsFinished( Builder $builder ) {
		return $builder->where( 'finished', true );
	}

	/**
	 * Get all finished Live
	 *
	 * @param Builder $builder
	 *
	 * @return Builder $builder
	 */
	public function scopeIsLive( Builder $builder ) {
		return $builder->where( 'live', true );
	}

	/**
	 * Get all public Events
	 *
	 * @param Builder $builder
	 *
	 * @return Builder $builder
	 */
	public function scopeIsPublic( Builder $builder ) {
		return $builder->where( 'private', false );
	}

	/**
	 * @param Builder $builder
	 * @param $identifier
	 *
	 * @return Builder $builder
	 */
	public function scopeFindByIdentifier( Builder $builder, $identifier ) {
		return $builder->where('identifier', $identifier);
	}

	/**
	 * @return string
	 */
	public function getRouteKeyName() {
		return 'identifier';
	}

	/**
	 *
	 */
	protected static function boot() {
		parent::boot();

		static::creating( function ( $file ) {
			$file->identifier = uniqid( true );
		} );
	}

}
