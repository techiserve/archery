@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="dashboard-shell">
    <div class="dashboard-heading mb-4">
      <div>
        <span class="dashboard-kicker">Welcome back</span>
        <h4 class="mb-1">Qurtuba Furusiyyah Dashboard</h4>
        <p class="mb-0 text-muted">A quick view of the people, events, and categories in the system.</p>
      </div>
      <a href="{{ route('events.create') }}" class="btn btn-primary dashboard-create-btn">
        <i class="icon-base bx bx-calendar-plus me-2"></i>
        New Event
      </a>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-12 col-md-6 col-xl-4">
        <a href="{{ route('achers.index') }}" class="dashboard-stat-tile dashboard-stat-archers">
          <span class="tile-glow"></span>
          <span class="dashboard-stat-icon">
            <i class="icon-base bx bx-user-circle"></i>
          </span>
          <span class="dashboard-stat-content">
            <span class="dashboard-stat-label">Archers in System</span>
            <span class="dashboard-stat-value">{{ number_format($dashboardStats['archers']) }}</span>
            <span class="dashboard-stat-meta">
              View all archers
              <i class="icon-base bx bx-right-arrow-alt"></i>
            </span>
          </span>
        </a>
      </div>

      <div class="col-12 col-md-6 col-xl-4">
        <a href="{{ route('events.indexevent') }}" class="dashboard-stat-tile dashboard-stat-events">
          <span class="tile-glow"></span>
          <span class="dashboard-stat-icon">
            <i class="icon-base bx bx-calendar-event"></i>
          </span>
          <span class="dashboard-stat-content">
            <span class="dashboard-stat-label">Open Events</span>
            <span class="dashboard-stat-value">{{ number_format($dashboardStats['openEvents']) }}</span>
            <span class="dashboard-stat-meta">
              Manage events
              <i class="icon-base bx bx-right-arrow-alt"></i>
            </span>
          </span>
        </a>
      </div>

      <div class="col-12 col-md-6 col-xl-4">
        <a href="{{ route('events.indexeventCategory') }}" class="dashboard-stat-tile dashboard-stat-categories">
          <span class="tile-glow"></span>
          <span class="dashboard-stat-icon">
            <i class="icon-base bx bx-category-alt"></i>
          </span>
          <span class="dashboard-stat-content">
            <span class="dashboard-stat-label">Event Categories</span>
            <span class="dashboard-stat-value">{{ number_format($dashboardStats['eventCategories']) }}</span>
            <span class="dashboard-stat-meta">
              View categories
              <i class="icon-base bx bx-right-arrow-alt"></i>
            </span>
          </span>
        </a>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-12 col-xl-8">
        <div class="dashboard-panel">
          <div class="dashboard-panel-header">
            <div>
              <span class="dashboard-kicker">Open event pulse</span>
              <h5 class="mb-0">Latest Open Events</h5>
            </div>
            <a href="{{ route('events.indexevent') }}" class="dashboard-panel-link">
              All events
              <i class="icon-base bx bx-right-arrow-alt"></i>
            </a>
          </div>

          <div class="dashboard-event-list">
            @forelse($latestOpenEvents as $event)
              <a href="{{ route('events.showEvent', $event->id) }}" class="dashboard-event-row">
                <span class="dashboard-event-date">
                  <i class="icon-base bx bx-calendar"></i>
                  {{ $event->doe ? \Carbon\Carbon::parse($event->doe)->format('d M Y') : 'No date' }}
                </span>
                <span class="dashboard-event-main">
                  <span class="dashboard-event-name">{{ $event->name ?? 'Untitled event' }}</span>
                  <span class="dashboard-event-category">{{ $eventCategories[$event->cat] ?? 'Uncategorised' }}</span>
                </span>
                <span class="dashboard-event-action">
                  Open
                  <i class="icon-base bx bx-chevron-right"></i>
                </span>
              </a>
            @empty
              <div class="dashboard-empty-state">
                <span class="dashboard-empty-icon">
                  <i class="icon-base bx bx-check-shield"></i>
                </span>
                <div>
                  <h6 class="mb-1">No open events right now</h6>
                  <p class="mb-0 text-muted">Create a new event when scoring is ready to begin.</p>
                </div>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="col-12 col-xl-4">
        <div class="dashboard-action-grid">
          <a href="{{ route('achers.index') }}" class="dashboard-action-tile">
            <span class="dashboard-action-icon bg-label-primary">
              <i class="icon-base bx bx-group"></i>
            </span>
            <span>
              <span class="dashboard-action-title">All Archers</span>
              <span class="dashboard-action-meta">Browse and update profiles</span>
            </span>
            <i class="icon-base bx bx-chevron-right dashboard-action-arrow"></i>
          </a>

          <a href="{{ route('events.indexevent') }}" class="dashboard-action-tile">
            <span class="dashboard-action-icon bg-label-success">
              <i class="icon-base bx bx-calendar-check"></i>
            </span>
            <span>
              <span class="dashboard-action-title">Events</span>
              <span class="dashboard-action-meta">Manage active and ended events</span>
            </span>
            <i class="icon-base bx bx-chevron-right dashboard-action-arrow"></i>
          </a>

          <a href="{{ route('events.indexeventCategory') }}" class="dashboard-action-tile">
            <span class="dashboard-action-icon bg-label-warning">
              <i class="icon-base bx bx-layer"></i>
            </span>
            <span>
              <span class="dashboard-action-title">Event Categories</span>
              <span class="dashboard-action-meta">Rounds, arrows, and scoring</span>
            </span>
            <i class="icon-base bx bx-chevron-right dashboard-action-arrow"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .dashboard-shell {
    color: #2f3349;
  }

  .dashboard-heading {
    align-items: center;
    display: flex;
    gap: 1rem;
    justify-content: space-between;
  }

  .dashboard-kicker {
    color: #6f6b7d;
    display: inline-flex;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: 0;
    margin-bottom: .25rem;
    text-transform: uppercase;
  }

  .dashboard-create-btn {
    align-items: center;
    display: inline-flex;
    flex: 0 0 auto;
    white-space: nowrap;
  }

  .dashboard-stat-tile {
    --tile-accent: #7367f0;
    --tile-soft: rgba(115, 103, 240, .12);
    background:
      linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(255, 255, 255, .88)),
      radial-gradient(circle at top right, var(--tile-soft), transparent 42%);
    border: 1px solid rgba(47, 51, 73, .08);
    border-radius: 8px;
    box-shadow: 0 10px 26px rgba(47, 51, 73, .08);
    color: inherit;
    display: flex;
    gap: 1rem;
    min-height: 168px;
    overflow: hidden;
    padding: 1.35rem;
    position: relative;
    text-decoration: none;
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
  }

  .dashboard-stat-tile:hover {
    border-color: color-mix(in srgb, var(--tile-accent) 42%, transparent);
    box-shadow: 0 16px 34px rgba(47, 51, 73, .14);
    color: inherit;
    transform: translateY(-4px);
  }

  .dashboard-stat-archers {
    --tile-accent: #00bad1;
    --tile-soft: rgba(0, 186, 209, .16);
  }

  .dashboard-stat-events {
    --tile-accent: #28c76f;
    --tile-soft: rgba(40, 199, 111, .15);
  }

  .dashboard-stat-categories {
    --tile-accent: #ff9f43;
    --tile-soft: rgba(255, 159, 67, .18);
  }

  .tile-glow {
    background: var(--tile-accent);
    border-radius: 8px 0 0 8px;
    bottom: 0;
    left: 0;
    opacity: .9;
    position: absolute;
    top: 0;
    width: 5px;
  }

  .dashboard-stat-icon {
    align-items: center;
    background: var(--tile-soft);
    border: 1px solid color-mix(in srgb, var(--tile-accent) 26%, transparent);
    border-radius: 8px;
    color: var(--tile-accent);
    display: inline-flex;
    flex: 0 0 54px;
    height: 54px;
    justify-content: center;
    width: 54px;
  }

  .dashboard-stat-icon i {
    font-size: 1.9rem;
  }

  .dashboard-stat-content {
    display: flex;
    flex: 1;
    flex-direction: column;
    min-width: 0;
  }

  .dashboard-stat-label {
    color: #6f6b7d;
    font-size: .95rem;
    font-weight: 700;
  }

  .dashboard-stat-value {
    color: #2f3349;
    font-size: clamp(2.2rem, 4vw, 3.25rem);
    font-weight: 800;
    letter-spacing: 0;
    line-height: 1.05;
    margin-top: .45rem;
  }

  .dashboard-stat-meta {
    align-items: center;
    color: var(--tile-accent);
    display: inline-flex;
    font-weight: 700;
    gap: .2rem;
    margin-top: auto;
  }

  .dashboard-panel {
    background: #fff;
    border: 1px solid rgba(47, 51, 73, .08);
    border-radius: 8px;
    box-shadow: 0 10px 26px rgba(47, 51, 73, .06);
    height: 100%;
    padding: 1.25rem;
  }

  .dashboard-panel-header {
    align-items: center;
    border-bottom: 1px solid rgba(47, 51, 73, .08);
    display: flex;
    gap: 1rem;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
  }

  .dashboard-panel-link {
    align-items: center;
    color: #7367f0;
    display: inline-flex;
    font-weight: 700;
    gap: .2rem;
    text-decoration: none;
    white-space: nowrap;
  }

  .dashboard-event-list {
    display: grid;
    gap: .75rem;
  }

  .dashboard-event-row {
    align-items: center;
    background: #f8f7fa;
    border: 1px solid transparent;
    border-radius: 8px;
    color: inherit;
    display: grid;
    gap: .9rem;
    grid-template-columns: 132px minmax(0, 1fr) auto;
    min-height: 76px;
    padding: .95rem 1rem;
    text-decoration: none;
    transition: background-color .2s ease, border-color .2s ease, transform .2s ease;
  }

  .dashboard-event-row:hover {
    background: #fff;
    border-color: rgba(115, 103, 240, .24);
    color: inherit;
    transform: translateX(4px);
  }

  .dashboard-event-date,
  .dashboard-event-action {
    align-items: center;
    color: #6f6b7d;
    display: inline-flex;
    font-size: .86rem;
    font-weight: 700;
    gap: .35rem;
    white-space: nowrap;
  }

  .dashboard-event-main,
  .dashboard-action-tile span {
    min-width: 0;
  }

  .dashboard-event-name,
  .dashboard-event-category,
  .dashboard-action-title,
  .dashboard-action-meta {
    display: block;
    overflow-wrap: anywhere;
  }

  .dashboard-event-name {
    color: #2f3349;
    font-weight: 800;
  }

  .dashboard-event-category {
    color: #6f6b7d;
    font-size: .86rem;
    margin-top: .15rem;
  }

  .dashboard-event-action {
    color: #28c76f;
  }

  .dashboard-empty-state {
    align-items: center;
    background: #f8f7fa;
    border: 1px dashed rgba(47, 51, 73, .18);
    border-radius: 8px;
    display: flex;
    gap: 1rem;
    min-height: 118px;
    padding: 1rem;
  }

  .dashboard-empty-icon {
    align-items: center;
    background: rgba(40, 199, 111, .14);
    border-radius: 8px;
    color: #28c76f;
    display: inline-flex;
    flex: 0 0 48px;
    height: 48px;
    justify-content: center;
    width: 48px;
  }

  .dashboard-empty-icon i {
    font-size: 1.7rem;
  }

  .dashboard-action-grid {
    display: grid;
    gap: .85rem;
    height: 100%;
  }

  .dashboard-action-tile {
    align-items: center;
    background: #f8f7fa;
    border: 1px solid transparent;
    border-radius: 8px;
    color: inherit;
    display: grid;
    gap: .85rem;
    grid-template-columns: 46px minmax(0, 1fr) auto;
    min-height: 86px;
    padding: .95rem;
    text-decoration: none;
    transition: background-color .2s ease, border-color .2s ease, transform .2s ease;
  }

  .dashboard-action-tile:hover {
    background: #fff;
    border-color: rgba(47, 51, 73, .12);
    color: inherit;
    transform: translateY(-2px);
  }

  .dashboard-action-icon {
    align-items: center;
    border-radius: 8px;
    display: inline-flex;
    height: 46px;
    justify-content: center;
    width: 46px;
  }

  .dashboard-action-icon i {
    font-size: 1.45rem;
  }

  .dashboard-action-title {
    color: #2f3349;
    font-weight: 800;
  }

  .dashboard-action-meta {
    color: #6f6b7d;
    font-size: .86rem;
    margin-top: .1rem;
  }

  .dashboard-action-arrow {
    color: #a8aaae;
    font-size: 1.35rem;
  }

  @media (max-width: 767.98px) {
    .dashboard-heading,
    .dashboard-panel-header {
      align-items: flex-start;
      flex-direction: column;
    }

    .dashboard-create-btn {
      justify-content: center;
      width: 100%;
    }

    .dashboard-event-row {
      align-items: flex-start;
      grid-template-columns: 1fr;
    }

    .dashboard-event-action {
      justify-self: start;
    }
  }
</style>
@endpush
