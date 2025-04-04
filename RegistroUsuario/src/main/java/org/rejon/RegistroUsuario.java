package org.rejon;

import java.util.HashSet;
import java.util.Set;

public class RegistroUsuario {

    private Set<Usuario> usuariosRegistrados = new HashSet<>();

    public boolean registrar(String nombreUsuario, String contraseña) {
        if (nombreUsuario == null || nombreUsuario.isEmpty()) {
            return false;
        }

        if (contraseña == null || contraseña.isEmpty()) {
            return false;
        }

        if (contraseña.length() < 8) {
            return false; // Nueva regla de longitud mínima
        }

        Usuario nuevoUsuario = new Usuario(nombreUsuario, contraseña);

        if (usuariosRegistrados.contains(nuevoUsuario)) {
            return false;
        }

        usuariosRegistrados.add(nuevoUsuario);
        return true;
    }

}