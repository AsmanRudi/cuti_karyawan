function SideNavBar() {
  return (
    <nav className="hidden md:flex flex-col h-full p-stack-md gap-stack-sm bg-surface-container-lowest border-r border-outline-variant fixed left-0 top-0 w-[280px] z-40">
      <div className="flex items-center gap-stack-md px-stack-sm mb-stack-lg mt-stack-sm">
        <span className="material-symbols-outlined text-h1 text-primary">work</span>
        <div>
          <h1 className="text-h3 font-h3 text-primary">HR Portal</h1>
          <p className="text-label-sm font-label-sm text-on-surface-variant">Enterprise Suite</p>
        </div>
      </div>
      <div className="flex flex-col gap-unit">
        <NavItem icon="dashboard" label="Dashboard" active fill />
        <NavItem icon="event_busy" label="Request Leave" />
        <NavItem icon="calendar_month" label="Team Calendar" />
        <NavItem icon="move_to_inbox" label="Approval Inbox" />
        <NavItem icon="badge" label="Employee Data" />
        <NavItem icon="assessment" label="Reports" />
        <NavItem icon="settings" label="Settings" className="mt-stack-lg" />
      </div>
    </nav>
  )
}

function NavItem({ icon, label, active, fill, className }) {
  return (
    <a
      className={`flex items-center gap-stack-md p-stack-sm rounded-lg text-label-md font-label-md transition-transform duration-150 ${
        active
          ? 'text-primary font-bold bg-secondary-container scale-[0.98]'
          : 'text-on-surface-variant hover:bg-surface-container-high'
      } ${className || ''}`}
      href="#"
    >
      <span className="material-symbols-outlined" style={fill ? { fontVariationSettings: "'FILL' 1" } : undefined}>
        {icon}
      </span>
      {label}
    </a>
  )
}

export default SideNavBar
