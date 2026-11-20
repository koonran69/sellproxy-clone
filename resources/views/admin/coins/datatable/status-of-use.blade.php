<span class="{{ is_null($usage_limit) ? 'text-green' : ($used_count < $usage_limit ? 'text-green' : 'text-red') }}">
    {{ is_null($usage_limit) ? $used_count : "$used_count / $usage_limit" }}
</span>
