<?php

namespace MyLibrary\Services;

use MyLibrary\Interfaces\CommonTreeService;
use MyLibrary\Models\TermsPostsTreeNode;

class TermsPostsTreeService extends CommonTreeService
{
    /**
     * Build the terms/posts tree.
     *
     * @param array $payload {
     * @type \WP_Term $root_term The root term node.
     * @type array $terms_map Map of term ID to an array of child \WP_Term objects, or (for leaf nodes) \WP_Post objects.
     * }
     * @return TermsPostsTreeNode
     */
    public function build(array $payload): TermsPostsTreeNode
    {
        // Extract and name variables for clarity
        /** @var \WP_Term $rootTerm */
        $rootTerm = $payload['root_term'];
        /** @var array $termsMap */
        $termsMap = $payload['terms_map'];

        $node = new TermsPostsTreeNode(
            $rootTerm->term_id,
            TermsPostsTreeNode::TYPE_TERM,
            $rootTerm
        );

        $children = $termsMap[$rootTerm->term_id] ?? [];

        foreach ($children as $child) {
            if ($child instanceof \WP_Term) {
                $node->children[] = $this->build([
                    'root_term' => $child,
                    'terms_map' => $termsMap,
                ]);
            } elseif ($child instanceof \MyLibrary\Models\Post) {
                $node->children[] = new TermsPostsTreeNode(
                    $child->getID(),
                    TermsPostsTreeNode::TYPE_POST,
                    $child
                );
            } elseif ($child instanceof \WP_Post) {
                $node->children[] = new TermsPostsTreeNode(
                    $child->ID,
                    TermsPostsTreeNode::TYPE_WP_POST,
                    $child
                );
            }
        }

        return $node;
    }
}
