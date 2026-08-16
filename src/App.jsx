import SideNavBar from './components/SideNavBar'
import TopNavBar from './components/TopNavBar'

function App() {
  return (
    <div className="min-h-screen bg-background text-on-background font-body-md antialiased">
      <SideNavBar />
      <TopNavBar />
      <main className="ml-0 md:ml-[280px] pt-[88px] pb-margin-desktop px-margin-mobile md:px-margin-desktop min-h-screen">
        <div className="max-w-container-max-width mx-auto flex flex-col gap-stack-lg">
          <PageHeader />
          <BentoGrid />
        </div>
      </main>
    </div>
  )
}

function PageHeader() {
  return (
    <div className="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
      <div>
        <h2 className="text-h1-mobile font-h1-mobile md:text-h1 md:font-h1 text-primary">
          Selamat Pagi, Budi!
        </h2>
        <p className="text-body-md font-body-md text-on-surface-variant mt-unit">
          Berikut adalah ringkasan kuota dan aktivitas cuti Anda.
        </p>
      </div>
      <button className="bg-primary-container text-on-primary border border-transparent px-6 py-3 rounded-lg text-label-md font-label-md shadow-sm hover:bg-primary transition-colors flex items-center gap-2 w-fit">
        <span className="material-symbols-outlined">edit_calendar</span>
        Ajukan Cuti
      </button>
    </div>
  )
}

function BentoGrid() {
  return (
    <div className="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
      <div className="lg:col-span-8 flex flex-col gap-stack-lg">
        <LeaveQuotaOverview />
        <RecentActivity />
      </div>
      <div className="lg:col-span-4 flex flex-col gap-stack-lg">
        <CalendarWidget />
        <QuickInfoBanner />
      </div>
    </div>
  )
}

function LeaveQuotaOverview() {
  return (
    <section>
      <h3 className="text-h3 font-h3 text-on-surface mb-stack-md">Ringkasan Kuota Cuti</h3>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-stack-md">
        <LeaveQuotaCard
          title="Cuti Tahunan"
          remaining="10"
          total="12"
          unit="Hari"
          topBarColor="bg-primary-container"
          svgColor="text-primary-container"
          numberColor="text-primary-container"
          badgeColor="bg-secondary-fixed text-primary-container"
          badgeText="Sisa 10 Hari"
          dasharray="83, 100"
          icon="beach_access"
        />
        <LeaveQuotaCard
          title="Cuti Sakit"
          remaining="4"
          total="5"
          unit="Hari"
          topBarColor="bg-secondary"
          svgColor="text-secondary"
          numberColor="text-secondary"
          badgeColor="bg-secondary-fixed-dim text-secondary"
          badgeText="Sisa 4 Hari"
          dasharray="20, 100"
          icon="medical_services"
        />
        <LeaveQuotaCard
          title="Cuti Melahirkan"
          remaining="90"
          total="90"
          unit="Hari"
          topBarColor="bg-tertiary-fixed-dim"
          svgColor="text-tertiary-fixed-dim"
          numberColor="text-tertiary-container"
          badgeColor="bg-tertiary-fixed text-tertiary-container"
          badgeText="Tersedia 90 Hari"
          dasharray="100, 100"
          icon="child_care"
        />
      </div>
    </section>
  )
}

function LeaveQuotaCard({ title, remaining, total, unit, topBarColor, svgColor, numberColor, badgeColor, badgeText, dasharray, icon }) {
  return (
    <div className={`bg-surface-container-lowest rounded-xl p-stack-md border border-outline-variant shadow-soft relative overflow-hidden group hover:border-primary-container transition-colors`}>
      <div className={`absolute top-0 left-0 w-full h-1 ${topBarColor}`}></div>
      <div className="flex flex-col items-center justify-center pt-stack-sm">
        <h4 className="text-body-md font-body-md text-on-surface-variant mb-stack-sm text-center">{title}</h4>
        <div className="relative w-28 h-28 flex items-center justify-center">
          <svg className="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
            <path
              className="text-surface-variant"
              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
              fill="none"
              stroke="currentColor"
              strokeWidth="3.5"
            ></path>
            <path
              className={svgColor}
              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
              fill="none"
              stroke="currentColor"
              strokeDasharray={dasharray}
              strokeLinecap="round"
              strokeWidth="3.5"
            ></path>
          </svg>
          <div className="absolute flex flex-col items-center">
            <span className={`text-h2 font-h2 ${numberColor} leading-none`}>{remaining}</span>
            <span className="text-label-sm font-label-sm text-on-surface-variant">/{total} {unit}</span>
          </div>
        </div>
        <p className={`text-label-sm font-label-sm mt-stack-md px-3 py-1 rounded-full ${badgeColor}`}>{badgeText}</p>
      </div>
    </div>
  )
}

function RecentActivity() {
  return (
    <section>
      <div className="flex items-center justify-between mb-stack-md">
        <h3 className="text-h3 font-h3 text-on-surface">Aktivitas Terbaru</h3>
        <a className="text-label-md font-label-md text-primary-container hover:underline flex items-center gap-1" href="#">
          Lihat Semua Riwayat
          <span className="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>
      </div>
      <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-soft overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-surface-container-low border-b border-outline-variant">
                <th className="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tipe Cuti</th>
                <th className="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Tanggal</th>
                <th className="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Durasi</th>
                <th className="py-3 px-4 text-label-sm font-label-sm text-on-surface-variant">Status</th>
              </tr>
            </thead>
            <tbody className="text-body-md font-body-md">
              <ActivityRow
                icon="beach_access"
                iconColor="text-primary-container"
                type="Cuti Tahunan"
                date="12 Okt - 14 Okt 2023"
                duration="3 Hari"
                status="Disetujui"
                statusColor="bg-primary-fixed text-on-primary-fixed"
              />
              <ActivityRow
                icon="medical_services"
                iconColor="text-secondary"
                type="Cuti Sakit"
                date="05 Sep 2023"
                duration="1 Hari"
                status="Disetujui"
                statusColor="bg-primary-fixed text-on-primary-fixed"
              />
              <ActivityRow
                icon="beach_access"
                iconColor="text-primary-container"
                type="Cuti Tahunan"
                date="25 Des - 29 Des 2023"
                duration="5 Hari"
                status="Menunggu"
                statusColor="bg-tertiary-fixed text-on-tertiary-fixed"
              />
              <ActivityRow
                icon="beach_access"
                iconColor="text-primary-container"
                type="Cuti Tahunan"
                date="17 Agu 2023"
                duration="1 Hari"
                status="Ditolak"
                statusColor="bg-error-container text-on-error-container"
              />
              <ActivityRow
                icon="beach_access"
                iconColor="text-primary-container"
                type="Cuti Tahunan"
                date="01 Mei - 02 Mei 2023"
                duration="2 Hari"
                status="Disetujui"
                statusColor="bg-primary-fixed text-on-primary-fixed"
              />
            </tbody>
          </table>
        </div>
      </div>
    </section>
  )
}

function ActivityRow({ icon, iconColor, type, date, duration, status, statusColor }) {
  return (
    <tr className="border-b border-outline-variant hover:bg-surface-container-high transition-colors">
      <td className="py-3 px-4 flex items-center gap-2">
        <span className={`material-symbols-outlined ${iconColor}`}>{icon}</span>
        {type}
      </td>
      <td className="py-3 px-4 text-on-surface-variant">{date}</td>
      <td className="py-3 px-4">{duration}</td>
      <td className="py-3 px-4">
        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm font-label-sm ${statusColor}`}>
          {status}
        </span>
      </td>
    </tr>
  )
}

function CalendarWidget() {
  return (
    <section className="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-md shadow-soft">
      <div className="flex items-center justify-between mb-stack-md">
        <h3 className="text-h3 font-h3 text-on-surface">Kalender Cuti</h3>
        <div className="flex items-center gap-2">
          <button className="text-on-surface-variant hover:text-primary"><span className="material-symbols-outlined">chevron_left</span></button>
          <span className="text-label-md font-label-md">Oktober 2023</span>
          <button className="text-on-surface-variant hover:text-primary"><span className="material-symbols-outlined">chevron_right</span></button>
        </div>
      </div>
      <div className="grid grid-cols-7 gap-1 text-center mb-stack-md">
        {['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'].map((day) => (
          <div key={day} className="text-label-sm font-label-sm text-on-surface-variant py-2">{day}</div>
        ))}
        <div className="p-2"></div>
        <div className="p-2"></div>
        <CalendarDay day={1} />
        <CalendarDay day={2} />
        <CalendarDay day={3} />
        <CalendarDay day={4} weekend />
        <CalendarDay day={5} weekend />
        <CalendarDay day={6} />
        <CalendarDay day={7} />
        <CalendarDay day={8} />
        <CalendarDay day={9} />
        <CalendarDay day={10} />
        <CalendarDay day={11} weekend />
        <CalendarDay day={12} highlight />
        <CalendarDay day={13} highlight />
        <CalendarDay day={14} highlight />
        <CalendarDay day={15} />
        <CalendarDay day={16} />
        <CalendarDay day={17} />
        <CalendarDay day={18} weekend />
        <CalendarDay day={19} weekend />
        <CalendarDay day={20} />
        <CalendarDay day={21} />
        <CalendarDay day={22} />
        <CalendarDay day={23} />
        <CalendarDay day={24} />
        <CalendarDay day={25} weekend />
        <CalendarDay day={26} weekend />
      </div>
      <div className="border-t border-outline-variant pt-stack-md mt-stack-md">
        <h4 className="text-label-sm font-label-sm text-on-surface-variant mb-stack-sm">Keterangan</h4>
        <div className="flex flex-col gap-2">
          <div className="flex items-center gap-2">
            <div className="w-3 h-3 rounded-full bg-primary-container"></div>
            <span className="text-body-sm font-body-sm text-on-surface">Cuti Anda</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="w-3 h-3 rounded-full bg-error-container border border-error"></div>
            <span className="text-body-sm font-body-sm text-on-surface">Hari Libur Nasional</span>
          </div>
        </div>
      </div>
    </section>
  )
}

function CalendarDay({ day, weekend, highlight }) {
  const baseClasses = "p-2 text-body-sm font-body-sm w-8 h-8 mx-auto flex items-center justify-center rounded-full"
  const weekendClass = weekend ? "text-outline" : "text-on-surface"
  const highlightClass = highlight ? "bg-primary-container text-on-primary" : ""
  
  return (
    <div className={`${baseClasses} ${weekendClass} ${highlightClass}`}>
      {day}
    </div>
  )
}

function QuickInfoBanner() {
  return (
    <div className="bg-surface-container-low border border-outline-variant rounded-xl p-stack-md flex gap-stack-md items-start">
      <span className="material-symbols-outlined text-secondary">info</span>
      <div>
        <h4 className="text-label-md font-label-md text-on-surface mb-1">Kebijakan Cuti 2023</h4>
        <p className="text-body-sm font-body-sm text-on-surface-variant">
          Sisa cuti tahunan yang tidak digunakan akan hangus pada akhir bulan Maret 2024. Pastikan Anda merencanakan cuti dengan baik.
        </p>
      </div>
    </div>
  )
}

export default App
