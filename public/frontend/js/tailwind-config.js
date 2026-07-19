tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['var(--font-sans)'],
        display: ['var(--font-display)'],
        accent: ['var(--font-accent)'],
        mono: ['var(--font-mono)'],
      },
      colors: {
        wine: 'oklch(0.38 0.13 18)',
        'wine-deep': 'oklch(0.27 0.11 20)',
        charcoal: 'oklch(0.22 0.01 60)',
        foreground: 'oklch(0.22 0.02 30)',
        gold: { DEFAULT: 'oklch(0.78 0.13 85)', soft: 'oklch(0.88 0.07 85)' },
        cream: 'oklch(0.975 0.015 80)',
        blush: 'oklch(0.92 0.04 15)',
        card: 'oklch(1 0 0)',
        secondary: 'oklch(0.88 0.07 85)',
        border: 'oklch(0.9 0.015 60)',
        muted: 'oklch(0.96 0.01 60)',
      },
      keyframes: {
        'scale-in': {
          from: { opacity: '0', transform: 'scale(0.96)' },
          to: { opacity: '1', transform: 'scale(1)' },
        },
      },
      animation: {
        'scale-in': 'scale-in 0.5s ease-out both',
      },
    },
  },
};
