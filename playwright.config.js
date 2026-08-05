import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
    testDir: './tests/E2E',
    fullyParallel: true,
    forbidOnly: !!process.env.CI,
    reporter: process.env.CI ? 'github' : 'list',
    use: {
        baseURL: process.env.PLAYWRIGHT_BASE_URL ?? 'http://localhost:5101',
        trace: 'on-first-retry',
    },
    projects: [
        {
            name: 'chromium',
            use: { ...devices['Desktop Chrome'] },
        },
    ],
});
