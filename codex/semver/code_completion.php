<?php


namespace Codex\Revisions {

    use Codex\Git\Support\GitRevisionCollectionMixin;
    use Codex\Mergable\ModelCollection;

    /**
     * @mixin GitRevisionCollectionMixin
     */
    class RevisionCollection extends ModelCollection
    {

        /**
         * resolveModels method
         *
         * @return array
         */
        protected function resolveLoadable()
        {
            // TODO: Implement resolveLoadable() method.
        }

        /**
         * resolveModels method
         *
         * @return mixed
         */
        protected function makeModel($key)
        {
            // TODO: Implement makeModel() method.
        }

        /**
         * getDefault method
         *
         * @return mixed
         */
        public function getDefaultKey()
        {
            // TODO: Implement getDefaultKey() method.
        }
    }
}
