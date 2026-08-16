function TopNavBar() {
  return (
    <header className="fixed top-0 right-0 w-full md:w-[calc(100%-280px)] h-16 bg-surface border-b border-outline-variant shadow-sm flex justify-between items-center px-margin-mobile md:px-margin-desktop z-30">
      <div className="flex items-center gap-stack-md">
        <button className="md:hidden text-on-surface"><span className="material-symbols-outlined">menu</span></button>
        <h2 className="text-h2 font-h2 font-bold text-primary hidden md:block">HR Portal</h2>
      </div>
      <div className="flex items-center gap-stack-lg">
        <div className="flex items-center gap-stack-sm">
          <button className="text-on-surface-variant hover:text-primary transition-colors p-unit rounded-full hover:bg-surface-container-high">
            <span className="material-symbols-outlined">notifications</span>
          </button>
          <button className="text-on-surface-variant hover:text-primary transition-colors p-unit rounded-full hover:bg-surface-container-high">
            <span className="material-symbols-outlined">settings_suggest</span>
          </button>
        </div>
        <div className="flex items-center gap-stack-md">
          <button className="bg-primary-container text-on-primary-container px-stack-md py-2 rounded-lg text-label-md font-label-md hover:opacity-80 transition-opacity">
            New Request
          </button>
          <img
            alt="User Profile Avatar"
            className="w-10 h-10 rounded-full border border-outline-variant object-cover"
            data-alt="A small circular avatar of a professional employee in a corporate setting, bright lighting, modern office background, high quality, realistic."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5eFXnWICsd_-Vr9Xf3GwtUsREUmQnl7fTg2FLnSDibEHvKfkUACutuRCyWFpxeDPq0BY-zof1U0vEThTVIFmJ3m8jWqf3Rn8VcNzKbUau0Y_VIrtrcP6X4EZHmUNuOkYObsFAm10tawHIAOm5ti1THNbVDlzpPFv9vuwPx2cAabGqiLi2SUJxO5c_R4KPo5-y6L6LM53EB6NEMlcliDJXs3TIeuwvINe7F1-a9TDZqcO8NXLqz8nD"
          />
        </div>
      </div>
    </header>
  )
}

export default TopNavBar
