package org.rejon;

import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

public class RegistroUsuarioTest {

    @Test
    public void testRegistroUsuarioExitoso() {
        RegistroUsuario registro = new RegistroUsuario();
        boolean resultado = registro.registrar("usuario123", "password123");

        assertTrue(resultado, "El usuario debería registrarse correctamente con datos válidos.");
    }

    @Test
    public void testRegistroFallaConNombreUsuarioVacio() {
        RegistroUsuario registro = new RegistroUsuario();
        boolean resultado = registro.registrar("", "password123");

        assertFalse(resultado, "El registro debe fallar si el nombre de usuario está vacío.");
    }

    @Test
    public void testRegistroFallaConNombreUsuarioNull() {
        RegistroUsuario registro = new RegistroUsuario();
        boolean resultado = registro.registrar(null, "password123");

        assertFalse(resultado, "El registro debe fallar si el nombre de usuario es null.");
    }

    @Test
    public void testRegistroFallaConContraseñaVacia() {
        RegistroUsuario registro = new RegistroUsuario();
        boolean resultado = registro.registrar("usuario123", "");

        assertFalse(resultado, "El registro debe fallar si la contraseña está vacía.");
    }

    @Test
    public void testRegistroFallaConContraseñaNull() {
        RegistroUsuario registro = new RegistroUsuario();
        boolean resultado = registro.registrar("usuario123", null);

        assertFalse(resultado, "El registro debe fallar si la contraseña es null.");
    }

    @Test
    public void testRegistroFallaSiUsuarioYaExiste() {
        RegistroUsuario registro = new RegistroUsuario();
        registro.registrar("usuario123", "password123");

        boolean resultadoDuplicado = registro.registrar("usuario123", "otraPassword");

        assertFalse(resultadoDuplicado, "No se debe permitir registrar un usuario ya existente.");
    }

    @Test
    public void testRegistroFallaSiContraseñaMuyCorta() {
        RegistroUsuario registro = new RegistroUsuario();
        boolean resultado = registro.registrar("usuarioNuevo", "12345");

        assertFalse(resultado, "El registro debe fallar si la contraseña tiene menos de 8 caracteres.");
    }

}