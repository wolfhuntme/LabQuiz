import js from "@eslint/js";
import globals from "globals";
import pluginReact from "eslint-plugin-react";
import pluginSecurity from "eslint-plugin-security";
import { defineConfig } from "eslint/config";
// ← SECTION 4.2: Import security-node plugin
import pluginSecurityNode from "eslint-plugin-security-node";
// ← SECTION 4.3: Import no-unsanitized plugin  
import pluginNoUnsanitized from "eslint-plugin-no-unsanitized";

export default defineConfig([
  { 
    files: ["**/*.{js,mjs,cjs,jsx}"], 
    plugins: { 
      js,
      security: pluginSecurity,
      // ← SECTION 4.2: Add security-node to plugins
      "security-node": pluginSecurityNode,
      // ← SECTION 4.3: Add no-unsanitized to plugins
      "no-unsanitized": pluginNoUnsanitized
    }, 
    extends: ["js/recommended"] 
  },
  { 
    files: ["**/*.{js,mjs,cjs,jsx}"], 
    languageOptions: { 
      globals: {
        ...globals.browser,
        ...globals.node  // ← ADD THIS LINE for Node.js globals
      }
    } 
  },
  pluginReact.configs.flat.recommended,
  // ← SECTION 4.2: Extend security-node/recommended
  {
    rules: {
      ...pluginSecurityNode.configs.recommended.rules
    }
  },
  // ← SECTION 4.3: Extend no-unsanitized/recommended  
  {
    rules: {
      ...pluginNoUnsanitized.configs.recommended.rules
    }
  },
  {
    rules: {
      "security/detect-eval-with-expression": "error"
    }
  }
]);