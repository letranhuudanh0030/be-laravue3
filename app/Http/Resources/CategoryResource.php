<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->when($this->slug, $this->slug),
            'is_child' => $this->when($this->isChild(), function () {
                return $this->isChild();
            }),
            'created_at_for_human' => $this->when($this->created_at, function () {
                return $this->created_at->diffForHumans();
            }),
            // 'parent' => $this->when($this->parent_id, function () {
            //     return $this->parent();
            // }),
            'parent' => $this->parent(),
            // 'parent_id' => $this->parent_id,
            $this->mergeWhen($this->children, function () {
                return [
                    'children' => $this->children,
                ];
            }),
            'articles_count' => $this->articles_count,
            'sort_order' => $this->sort_order
        ];
    }
}
