<button
    x-data="{}"
    x-on:click="$dispatch('open-modal', { id: 'database-notifications' })"
    type="button"
>
    Notifications ({{ $unreadNotificationsCount }} unread)
</button>